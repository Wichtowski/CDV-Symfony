import React from 'react';
import Link from 'next/link';
import { Author } from '@/interfaces/Users';

const AuthorCard: React.FC<{ author: Author }> = ({ author }) => (
    <div className="bg-gray-800 shadow-md rounded-lg p-4 h-full flex-1 text-center flex items-center justify-center container min-h-36 cursor-pointer hover:scale-95 transition-transform duration-250 ease-out">
        <Link href={`/authors/${author.id}`} className='card w-full'>
            <h2 className="text-gray-50 text-2xl">{author.name}</h2>
        </Link>
    </div>
);

export default AuthorCard;
