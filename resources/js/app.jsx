import React from 'react';
import ReactDOM from 'react-dom/client';
import LoginForm from './components/LoginForm';

// Mount LoginForm component
const loginFormElement = document.getElementById('login-form-root');
if (loginFormElement) {
    const props = JSON.parse(loginFormElement.dataset.props || '{}');
    const root = ReactDOM.createRoot(loginFormElement);
    root.render(<LoginForm {...props} />);
}
