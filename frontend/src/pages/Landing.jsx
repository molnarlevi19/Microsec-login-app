import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import UserInfoModal from './UserInfoModal';

const Landing = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [user, setUser] = useState(null);
  const [isFetched, setIsFetched] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) {
      navigate("/login");
      return;
    }

    const fetchUserData = async () => {
      const response = await fetch('/api/current-user', {
        headers: {
          'Authorization': `Bearer ${token}`,
        },
      });

      if (response.ok) {
        const data = await response.json();
        setUser(data);
        setIsFetched(true); 

      } else {
        localStorage.removeItem('token');
        navigate("/login");
      }
    };

    if (!isFetched) { 
      fetchUserData();
    }
  }, [navigate, isFetched]); 

  const handleLogout = async () => {
    const logoutUrl = '/api/logout';

    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
      },
    };

    try {
      const response = await fetch(logoutUrl, requestOptions);

      if (response.ok) {
        localStorage.removeItem('token');
        navigate("/login");
      } else {
        console.error('Logout failed');
      }
    } catch (error) {
      console.error('Error during logout:', error);
    }
  };

  const handleUpdateUser = async (updatedUserData) => {
    const updateUrl = '/api/update-profile';
    const requestOptions = {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
      },
      body: JSON.stringify(updatedUserData),
    };

    try {
      const response = await fetch(updateUrl, requestOptions);
      if (response.ok) {
        const updatedUser = await response.json();
        setUser(updatedUser.user);
      } else {
        console.error('Failed to update user information');
      }
    } catch (error) {
      console.error('Error updating user information:', error);
    }
  };

  return (
    <div className="landing-container">
      <h1>Welcome to the Landing Page!</h1>
      {user && (
        <>
          <p>You are now logged in.</p>
          <button onClick={() => setIsModalOpen(true)}>Change User Information</button>
        </>
      )}
      <button onClick={handleLogout}>Logout</button>
      {isModalOpen && user && (
        <UserInfoModal
          isOpen={isModalOpen}
          onClose={() => setIsModalOpen(false)}
          user={user}
          onUpdate={handleUpdateUser}
        />
      )}
    </div>
  );
};

export default Landing;
