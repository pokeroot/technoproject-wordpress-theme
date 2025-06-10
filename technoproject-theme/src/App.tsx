// technoproject-theme/src/App.tsx
import React from 'react';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import CourseList from './components/organisms/CourseList';
import CourseDetailPage from './components/pages/CourseDetailPage'; // Import the actual component

const Layout: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div>
    <header style={{ padding: '20px', backgroundColor: '#f0f0f0', textAlign: 'center' }}>
      <nav>
        <Link to="/" style={{ marginRight: '10px' }}>Inicio</Link>
        <Link to="/cursos" style={{ marginRight: '10px' }}>Cursos</Link>
        {/* Assuming /cursos will also show CourseList or a catalog page later */}
      </nav>
    </header>
    <main style={{ padding: '20px' }}>
      {children}
    </main>
    <footer style={{ padding: '20px', backgroundColor: '#333', color: 'white', textAlign: 'center', marginTop: '40px' }}>
      <p>&copy; {new Date().getFullYear()} Technoproject. Todos los derechos reservados.</p>
    </footer>
  </div>
);

const App: React.FC = () => {
  return (
    <BrowserRouter>
      <Layout>
        <Routes>
          <Route path="/" element={<CourseList />} />
          <Route path="/cursos" element={<CourseList />} /> {/* Added /cursos route */}
          <Route path="/cursos/:courseId" element={<CourseDetailPage />} /> {/* Using actual component */}
          <Route path="*" element={<div><h2>404 - Página No Encontrada</h2><Link to="/">Volver al Inicio</Link></div>} />
        </Routes>
      </Layout>
    </BrowserRouter>
  );
};

export default App;
