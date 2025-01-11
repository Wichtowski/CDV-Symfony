"use client";

import React, { useEffect, useState } from 'react';
import { getAllArticles } from '@/api/Articles/get/allArticles';
import NavLink from '@/components/utils/NavLink';
import ArticleCard from '@/components/utils/ArticleCard';
import { Article } from '@/interfaces/Article';

const ListAllArticles: React.FC = () => {
    const [articles, setAllArticles] = useState<Article[]>([]);
    const [loading, setLoading] = useState<boolean>(true);

    useEffect(() => {
        const fetchArticles = async () => {
            try {
                const data = await getAllArticles();
                setAllArticles(data);
            } catch (error) {
                console.error('Error fetching Articles:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchArticles();
    }, []);

    if (loading) {
        return (
            <div className="">
                <div className='flex flex-wrap flex-col gap-6 m-4 max-w-96 mx-auto'>
                    {[...Array(5)].map((_, index) => (
                        <ArticleCard
                            key={index}
                            article={{ id: index, title: 'Loading...', author: '', content: '' }}
                            cutContent={false}
                            customTitleStyles=""
                            isSingle={true}
                        />
                    ))}
                </div>
                <NavLink href="/" />
            </div >
        )
    }
    return (
        <div className='flex flex-wrap flex-col gap-6 m-4 max-w-96 mx-auto'>
            {Array.isArray(articles) ? articles.map((article) => (
                <ArticleCard
                    key={article.id}
                    article={article}
                    cutContent={true}
                />
            )) : <p>No articles available</p>}
            <NavLink href="/" />
        </div>
    );
};

export default ListAllArticles;
