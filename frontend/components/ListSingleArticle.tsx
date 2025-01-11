"use client";

import React from 'react';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import { getSingleArticle } from '@/api/Articles/get/singleArticle';
import { Article } from '@/interfaces/Article';
import NavLink from '@/components/utils/NavLink';
import ArticleCard from '@/components/utils/ArticleCard';

interface ListSingleArticleProps {
    articleID: number;
}

const ListSingleArticle: React.FC<ListSingleArticleProps> = ({ articleID }) => {
    const [articles, setAllArticles] = useState<Article[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const router = useRouter();

    useEffect(() => {
        const fetchArticles = async () => {
            try {
                if (articleID > 0 && !isNaN(articleID)) {
                    const data = await getSingleArticle(articleID);

                    setAllArticles([data]);
                } else {
                    router.push('/articles');
                }
            } catch (error) {
                console.error('Error fetching Articles:', error);
                router.push('/articles');
            } finally {
                setLoading(false);
            }
        };

        fetchArticles();
    }, [articleID]);

    if (loading) {
        return (
            <div className="">
                <div className='shadow-lg rounded-lg p-6 h-full flex-1 text-center flex items-center justify-center'>
                    <ArticleCard
                        key={0}
                        article={{ id: 0, title: '', author: '', content: '' }}
                        cutContent={false}
                        customTitleStyles=""
                        isSingle={true}
                    />
                </div>
                <NavLink href="/articles" />
            </div>
        )
    }

    return (
        <div className="">
            <div className='shadow-lg rounded-lg p-6 h-full flex-1 text-center flex items-center justify-center'>
                {articles.map((article) => (
                    <ArticleCard
                        key={article.id}
                        article={article}
                        cutContent={false}
                        customTitleStyles=""
                        isSingle={true}
                    />
                ))}
            </div>
            <NavLink href="/articles" />
        </div>
    );
};

export default ListSingleArticle;
