import React from 'react';
import Link from 'next/link';
import { Article } from '@/interfaces/Article';

interface ArticleCardProps {
    article: Article;
    cutContent?: boolean;
    isSingle?: boolean;
    customTitleStyles?: string;
    customAuthorStyles?: string;
    customContentStyles?: string;
}

const ArticleCard: React.FC<ArticleCardProps> = ({ article, cutContent = false, isSingle = false, customTitleStyles, customAuthorStyles, customContentStyles }) => (
    <div className={`bg-gray-800 shadow-md rounded-lg p-4 h-full flex-1 text-center flex items-center justify-center container min-h-36  ${!isSingle ? "cursor-pointer hover:scale-95 transition-transform duration-250 ease-out" : ""}`} >
        {!isSingle ? (
            <Link href={`/articles/${article.id}`} className='card w-full'>
                <h2 className={`text-xl font-semibold mb-2 text-white ${customTitleStyles}`}>{article.title}</h2>
                <p className={`text-gray-400 mb-4 ${customAuthorStyles}`}>{article.author}</p>
                {/* <p className={customContentStyles}>{cutContent ? article.content.split(' ').slice(0, 5).join(' ') + "..." : article.content}</p> */}
            </Link>
        ) : (
            <div>
                <h2 className={`text-xl font-semibold mb-2 text-white ${customTitleStyles}`}>{article.title}</h2>
                <p className={`text-gray-400 mb-4 ${customAuthorStyles}`}>{article.author}</p>
                {/* <p className={customContentStyles}>{cutContent ? article.content.split(' ').slice(0, 5).join(' ') + "..." : article.content}</p> */}
            </div>
        )}
    </div>
);

export default ArticleCard;