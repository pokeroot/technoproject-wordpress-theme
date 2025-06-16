// technoproject-theme/src/App.tsx
import React from 'react';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import CourseList from './components/organisms/CourseList';
import CourseDetailPage from './components/pages/CourseDetailPage'; // Import the actual component
import { Header } from './components/organisms/Header'; // Assuming index.ts exports it
import { Footer } from './components/organisms/Footer'; // Assuming index.ts exports it
import styles from './App.module.scss'; // Create this file for App/Layout specific styles

const Layout: React.FC<{ children: React.ReactNode }> = ({ children }) => (
  <div className={styles.appWrapper}> {/* Optional: for overall app structure */}
    <Header />
    <main className={styles.mainContent}> {/* Add class for styling */}
      {children}
    </main>
    <Footer />
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
