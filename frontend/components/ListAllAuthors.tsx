"use client";

import React, { useEffect, useState } from 'react';
import { useArticlesStore } from '@/store/ArticleStore';
import NavLink from '@/components/utils/NavLink';
import AuthorCard from '@/components/utils/AuthorCard';
import { Author } from '@/interfaces/Users';

const ListAllAuthors: React.FC = () => {
    const authorsStatus = useArticlesStore((state) => state.articlesStatus);
    const loadAuthors = useArticlesStore((state) => state.loadAuthors);
    const authors = useArticlesStore((state) => state.authors);

    useEffect(() => {
        Promise.all([loadAuthors()]);
    }, []);

    if (authorsStatus != 'Ready') {
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
            </div>
        )
    }
    return (
        <div className='flex flex-wrap flex-col gap-6 m-4 max-w-96 mx-auto'>
            {Array.isArray(authors) && authors.length > 0 ? authors.map((author) => (
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
