import React, { useState, useEffect } from 'react';

const UserInfoModal = ({ isOpen, onClose, user, onUpdate }) => {
  const [formData, setFormData] = useState({ nickname: '', birthdate: '', password: '' });

  useEffect(() => {
    if (user) {
      setFormData({ nickname: user.nickname || '', birthdate: user.birthdate || '', password: '' });
    }
  }, [user]);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
  
    const updatedData = {};
    Object.keys(formData).forEach(key => {
      if (formData[key] && formData[key] !== user[key]) {
        updatedData[key] = formData[key];
      }
    });
  
    await onUpdate(updatedData);  
    onClose();
  };

  if (!isOpen) return null;

  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <h2>Update User Information</h2>
        <form onSubmit={handleSubmit}>
          <div>
            <label htmlFor="nickname">Nickname:</label>
            <input
              type="text"
              name="nickname"
              value={formData.nickname}
              onChange={handleChange}
            />
          </div>
          <div>
            <label htmlFor="birthdate">Birthdate:</label>
            <input
              type="date"
              name="birthdate"
              value={formData.birthdate}
              onChange={handleChange}
            />
          </div>
          <div>
            <label htmlFor="password">Password:</label>
            <input
              type="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              placeholder=""
            />
          </div>
          <button type="submit">Update</button>
          <button type="button" onClick={onClose}>Cancel</button>
        </form>
      </div>
    </div>
  );
};

export default UserInfoModal;
