import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const Register = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: '',
    nickname: '',
    birthdate: '',
    password: '',
  });
  const [message, setMessage] = useState('');

  function clearInputs() {
    setFormData({
      email: '',
      nickname: '',
      birthdate: '',
      password: '',
    });
  }

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const registerUrl = 'api/register';

    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formData)
    };

    try {
      const response = await fetch(registerUrl, requestOptions);
      const data = await response.json();

      if (!response.ok) {
        setMessage(data.message || 'Registration failed');
        clearInputs();
      } else {
        setMessage('Registration successful');
        navigate("/login"); 
      }
    } catch (error) {
      setMessage('Error occurred during registration');
      console.error(error);
    }
  };

  return (
    <div>
      <h2>Register</h2>
      {message && <p>{message}</p>}
      <form onSubmit={handleSubmit}>
        <input
          type="email"
          name="email"
          placeholder="Email"
          value={formData.email}
          onChange={handleChange}
          required
        />
        <input
          type="text"
          name="nickname"
          placeholder="Nickname"
          value={formData.nickname}
          onChange={handleChange}
          required
        />
        <input
          type="date"
          name="birthdate"
          value={formData.birthdate}
          onChange={handleChange}
          required
        />
        <input
          type="password"
          name="password"
          placeholder="Password"
          value={formData.password}
          onChange={handleChange}
          minLength={8}
          required
        />
        <button type="submit">Register</button>
      </form>
    </div>
  );
};

export default Register;
