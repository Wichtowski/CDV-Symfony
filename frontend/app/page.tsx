import React from 'react';
import NavLink from '@/components/utils/NavLink';

const HomePage: React.FC = () => {
    return (
        <div>
            <h1>Home Page</h1>
            <NavLink href="/articles" />
        </div>
    );
};

export default HomePage;
