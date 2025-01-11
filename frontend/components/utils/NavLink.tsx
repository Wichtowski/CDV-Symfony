'use client';

import React from 'react';
import { useRouter } from 'next/navigation';

interface NavLinkProps {
    href: string;
    label?: string;
}

const NavLink: React.FC<NavLinkProps> = ({ href = '/', label = 'Go Back' }) => {
    const router = useRouter();

    return (
        <div className='w-full mt-4 text-blue-500 hover:text-blue-700 font-semibold flex justify-center'>
            <button type="button" onClick={() => router.push(href)}>
                {label}
            </button>
        </div>
    );
};

export default NavLink;
