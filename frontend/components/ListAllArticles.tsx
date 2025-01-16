"use client";

import React, { useEffect, useState } from 'react';
import { useArticlesStore } from '@/store/ArticleStore';
import NavLink from '@/components/utils/NavLink';
import ArticleCard from '@/components/utils/ArticleCard';
import { Article } from '@/interfaces/Article';

const ListAllArticles: React.FC = () => {
    const articlesStatus = useArticlesStore((state) => state.articlesStatus);
    const loadArticles = useArticlesStore((state) => state.loadArticles);
    const articles = useArticlesStore((state) => state.articles);

    useEffect(() => {
        Promise.all([loadArticles()]);
    }, []);

    if (articlesStatus != 'Ready') {
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
            {Array.isArray(articles) && articles.length > 0 ? articles.map((article: Article) => (
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
