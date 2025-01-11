'use client';

import React from 'react';
import LogInForm from '@/components/LogInFrom';
import Navbar from '@/components/Navbar';

const LoginPage: React.FC = () => {
    return (
        <div>
            <Navbar />
            <h1 className='text-4xl text-center mt-8'>Login</h1>
            <LogInForm />
        </div>
    );
};

export default LoginPage;