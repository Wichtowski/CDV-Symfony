"use client";

import React, { useEffect, useState } from 'react';
import { getAllAuthors } from '@/api/Authors/get/allAuthors';
import NavLink from '@/components/utils/NavLink';
import AuthorCard from '@/components/utils/AuthorCard';
import { Author } from '@/interfaces/Users';

const ListAllAuthors: React.FC = () => {
    const [authors, setAllAuthors] = useState<Author[]>([]);
    const [loading, setLoading] = useState<boolean>(true);

    useEffect(() => {
        const fetchAuthors = async () => {
            try {
                const data = await getAllAuthors();
                setAllAuthors(data);
            } catch (error) {
                console.error('Error fetching Authors:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchAuthors();
    }, []);

    if (loading) {
        return (
            <div className="">
                <div className='flex flex-wrap flex-col gap-6 m-4 max-w-96 mx-auto'>
                    {[...Array(5)].map((_, index) => (
                        <AuthorCard
                            key={index}
                            author={{ id: index, name: 'Loading...', email: '', password: '' }}
                        />
                    ))}
                </div>
                <NavLink href="/" />
            </div >
        )
    }
    return (
        <div className='flex flex-wrap flex-col gap-6 m-4 max-w-96 mx-auto'>
            {Array.isArray(authors) ? authors.map((author) => (
                <AuthorCard
                    key={author.id}
                    author={author}
                />
            )) : <p>No articles available</p>}
            <NavLink href="/" />
        </div>
    );
};

export default ListAllAuthors;
