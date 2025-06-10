// technoproject-theme/src/index.tsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App'; // Import the new App component
import './styles/globals/main.scss';

const container = document.getElementById('root');

if (container) {
  const root = ReactDOM.createRoot(container);
  root.render(
    <React.StrictMode>
      <App />
    </React.StrictMode>
  );
} else {
  console.error('Failed to find the root element. Please ensure an element with id="root" exists in your HTML (src/index.html).');
}
