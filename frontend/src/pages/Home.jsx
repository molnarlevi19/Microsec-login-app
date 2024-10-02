import React from 'react';
import { useNavigate } from 'react-router-dom';

const Home = () => {
  const navigate = useNavigate();

  const goToLogin = () => {
    navigate('/login');
  };

  const goToRegister = () => {
    navigate('/register');
  };

  return (
    <div className="home-container">
      <h1>Welcome to the Home Page</h1>
      <div className="button-container">
        <button onClick={goToLogin}>Login</button>
        <button onClick={goToRegister}>Register</button>
      </div>
    </div>
  );
};

export default Home;
