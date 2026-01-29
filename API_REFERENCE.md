#  API & Development Reference

## Table of Contents
1. [Model Relationships](#model-relationships)
2. [Common Controller Methods](#common-controller-methods)
3. [Middleware & Policies](#middleware--policies)
4. [Service Layer Patterns](#service-layer-patterns)
5. [Form Requests](#form-requests)
6. [Query Optimization](#query-optimization)
7. [Response Format](#response-format)

---

## Model Relationships

### User Model
```php
// User.php
class User extends Model {
    // Relationships
    public function programs()       // Super Admin - Programs dibuat
    public function activities()     // Admin Mappings
    public function classes()        // Fasilitator Mappings
    public function grades()         // Peserta Grades
    public function documents()      // Documents uploaded
    public function mappings()       // Admin/Fasilitator/Participant Mappings
}
```

### Program Model
```php
// Program.php
class Program extends Model {
    public function activities()     // One-to-Many
    public function adminMappings()  // One-to-Many
    public function creator()        // BelongsTo User (super_admin)
}
```

### Activity Model
```php
// Activity.php
class Activity extends Model {
    public function program()        // BelongsTo Program
    public function classes()        // One-to-Many
    public function adminMappings()  // One-to-Many
    public function registrations()  // One-to-Many (via ActivityRegistration)
}
```

### Class Model
```php
// Class.php
class Kelas extends Model {
    public function activity()       // BelongsTo Activity
    public function fasilitators()   // Many-to-Many via FasilitatorMapping
    public function participants()   // Many-to-Many via ParticipantMapping
    public function grades()         // One-to-Many
    public function documents()      // One-to-Many
}
```

### Grade Model
```php
// Grade.php
class Grade extends Model {
    public function kelas()          // BelongsTo Kelas
    public function peserta()        // BelongsTo User
    public function fasilitator()    // BelongsTo User
}
```

---

## Common Controller Methods

### Super Admin Controller Pattern

```php
// SuperAdminController.php
class SuperAdminController extends Controller {
    
    // List view
    public function users() {
        $users = User::where('role', '!=', 'super_admin')
                    ->paginate(15);
        return view('super-admin.users.index', compact('users'));
    }
    
    // Create view
    public function createUser() {
        $roles = ['admin', 'fasilitator', 'peserta'];
        return view('super-admin.users.create', compact('roles'));
    }
    
    // Store user
    public function storeUser(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,fasilitator,peserta',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        
        return redirect()->route('super-admin.users')
                        ->with('success', 'User created successfully');
    }
    
    // Edit view
    public function editUser(User $user) {
        return view('super-admin.users.edit', compact('user'));
    }
    
    // Update user
    public function updateUser(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        
        $user->update($validated);
        
        return redirect()->back()->with('success', 'User updated');
    }
    
    // Delete user
    public function deleteUser(User $user) {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted');
    }
}
```

### Fasilitator Controller Pattern

```php
// FasilitatorController.php
class FasilitatorController extends Controller {
    
    // Get fasilitator's classes
    public function classes() {
        $classes = auth()->user()
                   ->classes()
                   ->with('activity', 'participants')
                   ->paginate(10);
        return view('fasilitator.classes.index', compact('classes'));
    }
    
    // Get class detail
    public function classDetail(Kelas $class) {
        $this->authorize('view', $class);
        
        $participants = $class->participants()
                             ->with('user')
                             ->paginate(20);
        
        return view('fasilitator.classes.detail', compact('class', 'participants'));
    }
    
    // Input grades
    public function storeGrades(Request $request, Kelas $class) {
        $this->authorize('update', $class);
        
        $validated = $request->validate([
            'grades.*.peserta_id' => 'required|exists:users,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',
            'grades.*.notes' => 'nullable|string',
        ]);
        
        foreach ($validated['grades'] as $grade) {
            Grade::updateOrCreate(
                [
                    'class_id' => $class->id,
                    'peserta_id' => $grade['peserta_id'],
                    'fasilitator_id' => auth()->id(),
                ],
                [
                    'score' => $grade['score'],
                    'notes' => $grade['notes'] ?? null,
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Grades saved');
    }
}
```

---

## Middleware & Policies

### Custom Middleware

```php
// app/Http/Middleware/RoleMiddleware.php
class RoleMiddleware {
    public function handle(Request $request, Closure $next, ...$roles) {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}

// Usage in route
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    // Protected routes
});
```

### Authorization Policies

```php
// app/Policies/KelasPolicy.php
class KelasPolicy {
    public function view(User $user, Kelas $kelas) {
        return $user->role === 'fasilitator' && 
               $user->classes()->where('id', $kelas->id)->exists();
    }
    
    public function update(User $user, Kelas $kelas) {
        return $user->role === 'admin' || $user->role === 'super_admin';
    }
    
    public function delete(User $user, Kelas $kelas) {
        return $user->role === 'super_admin';
    }
}

// Usage
$this->authorize('view', $kelas);
$this->authorize('update', $kelas);
```

---

## Service Layer Patterns

### Document Service

```php
// app/Services/DocumentService.php
class DocumentService {
    
    public function uploadDocument($file, $type, User $user, $class_id = null) {
        $filename = $this->generateFilename($file);
        $path = "documents/{$type}/" . date('Y/m/d');
        
        $stored = Storage::putFileAs(
            "public/{$path}",
            $file,
            $filename
        );
        
        Document::create([
            'user_id' => $user->id,
            'class_id' => $class_id,
            'document_type' => $type,
            'file_path' => $stored,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
        ]);
        
        return true;
    }
    
    private function generateFilename($file) {
        return time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    }
    
    public function deleteDocument(Document $document) {
        Storage::delete($document->file_path);
        $document->delete();
    }
}
```

### Grade Service

```php
// app/Services/GradeService.php
class GradeService {
    
    public function calculateClassAverage(Kelas $class) {
        return $class->grades()
                    ->avg('score');
    }
    
    public function getPesertaGrades(User $peserta, Kelas $class) {
        return Grade::where('peserta_id', $peserta->id)
                   ->where('class_id', $class->id)
                   ->first();
    }
    
    public function getTopPerformers(Kelas $class, $limit = 10) {
        return Grade::where('class_id', $class->id)
                   ->with('peserta')
                   ->orderByDesc('score')
                   ->limit($limit)
                   ->get();
    }
}
```

---

## Form Requests

### User Form Request

```php
// app/Http/Requests/StoreUserRequest.php
class StoreUserRequest extends FormRequest {
    
    public function authorize() {
        return auth()->user()->role === 'super_admin';
    }
    
    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'npsn' => 'nullable|unique:users|digits:8',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,fasilitator,peserta,sekolah',
            'phone' => 'nullable|string|max:20',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
        ];
    }
    
    public function messages() {
        return [
            'name.required' => 'Nama harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'npsn.digits' => 'NPSN harus 8 digit',
        ];
    }
}
```

### Class Form Request

```php
// app/Http/Requests/StoreKelasRequest.php
class StoreKelasRequest extends FormRequest {
    
    public function rules() {
        return [
            'activity_id' => 'required|exists:activities,id',
            'batch_number' => 'required|integer|min:1',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date',
            'capacity' => 'required|integer|min:1|max:100',
        ];
    }
}
```

---

## Query Optimization

### N+1 Problem BAD

```php
$classes = Kelas::all();
foreach ($classes as $class) {
    echo $class->activity->name;  // N queries!
}
```

### N+1 Problem - GOOD

```php
$classes = Kelas::with('activity')->get();
foreach ($classes as $class) {
    echo $class->activity->name;  // 1 query
}
```

### Complex Queries

```php
// Get active classes with participants and grades
$classes = Kelas::where('status', 'active')
    ->with([
        'activity' => fn($q) => $q->select('id', 'name'),
        'participants' => fn($q) => $q->select('id', 'name'),
        'grades' => fn($q) => $q->select('class_id', 'peserta_id', 'score'),
    ])
    ->paginate(15);

// Count grades per class
$classes = Kelas::withCount('grades')
    ->get();

// Filter and search
$classes = Kelas::where('activity_id', $activity_id)
    ->whereHas('participants', function($q) {
        $q->where('status', 'active');
    })
    ->search($request->search)
    ->paginate(15);
```

---

## Response Format

### Success Response

```php
return response()->json([
    'success' => true,
    'message' => 'Operation successful',
    'data' => [
        'id' => 1,
        'name' => 'Class A',
        'participants_count' => 30,
    ],
], 200);
```

### Error Response

```php
return response()->json([
    'success' => false,
    'message' => 'Validation error',
    'errors' => [
        'email' => ['Email is required'],
        'password' => ['Password must be at least 8 characters'],
    ],
], 422);
```

### Paginated Response

```php
$classes = Kelas::paginate(15);

return response()->json([
    'success' => true,
    'data' => $classes->items(),
    'pagination' => [
        'total' => $classes->total(),
        'per_page' => $classes->perPage(),
        'current_page' => $classes->currentPage(),
        'last_page' => $classes->lastPage(),
    ],
], 200);

**Last Updated**: 29 Januari 2026
