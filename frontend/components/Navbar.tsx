"use client";

import React, { useState, useEffect } from 'react';
import BurgerMenu from './utils/Icons/BurgerMenu';

interface NavbarProps {
    mobileElements?: { name: string; link: string }[];
    desktopElements?: { name: string; link: string }[];
}

const Navbar = ({ mobileElements: customMobileElements, desktopElements: customDesktopElements }: NavbarProps) => {
    const [isOpen, setIsOpen] = useState(false);

    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }, [isOpen]);

    const defaultMobileElements = [
        { name: 'Home', link: '/' },
        { name: 'Articles', link: '/articles' },
        { name: 'Authors', link: '/authors' },
        { name: 'Contact', link: '/contact' },
    ];

    const defaultDesktopElements = [
        { name: 'Home', link: '/' },
        { name: 'Articles', link: '/articles' },
        { name: 'Authors', link: '/authors' },
        { name: 'Contact', link: '/contact' },
    ];

    const mobileElements = customMobileElements || defaultMobileElements;
    const desktopElements = customDesktopElements || defaultDesktopElements;

    return (
        <nav className="bg-gray-900 h-20 flex justify-center items-center text-lg sticky top-0 z-50">
            <div className="container mx-auto flex justify-between items-center h-full px-6">
                <div className="text-white text-2xl">
                    <a href="/">Logo</a>
                </div>
                <div className="block lg:hidden cursor-pointer" onClick={toggleMenu}>
                    <BurgerMenu />
                </div>
                <div className={`lg:flex items-center list-none transition-all duration-500 ease-in-out overflow-hidden fixed top-20 left-0 w-full bg-gray-900 z-50 ${isOpen ? 'h-[calc(100vh-5rem)]' : 'h-0'}`}>
                    <ul className="flex flex-col w-full items-center lg:hidden">
                        {mobileElements.map((li, index) => (
                            <li key={index} className="lg:inline-block">
                                <a href={li.link} className="block px-4 py-3 text-white text-xl hover:bg-gray-700 transition duration-125 rounded">{li.name}</a>
                            </li>
                        ))}
                    </ul>
                </div>
                <ul className="hidden lg:flex items-center list-none">
                    {desktopElements.map((li, index) => (
                        <li key={index} className="lg:inline-block">
                            <a href={li.link} className="block px-4 py-3 text-white text-xl hover:bg-gray-700 transition duration-125 rounded">{li.name}</a>
                        </li>
                    ))}
                </ul>
            </div>
        </nav>
    );
};

export default Navbar;