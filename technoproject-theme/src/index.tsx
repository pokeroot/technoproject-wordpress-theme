// technoproject-theme/src/index.tsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import CourseList from './components/organisms/CourseList';

// Placeholder for global styles - create this file later
// import './styles/globals/main.scss';

const container = document.getElementById('root');

if (container) {
  const root = ReactDOM.createRoot(container);
  root.render(
    <React.StrictMode>
      <header style={{ padding: '20px', backgroundColor: '#f0f0f0', textAlign: 'center' }}>
        <h1>Plataforma de Cursos Technoproject</h1>
      </header>
      <main style={{ padding: '20px' }}>
        <CourseList />
      </main>
      <footer style={{ padding: '20px', backgroundColor: '#333', color: 'white', textAlign: 'center', marginTop: '40px' }}>
        <p>&copy; ${new Date().getFullYear()} Technoproject. Todos los derechos reservados.</p>
      </footer>
    </React.StrictMode>
  );
} else {
  console.error('Failed to find the root element. Please ensure an element with id="root" exists in your HTML (src/index.html).');
}
