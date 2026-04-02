'use client';

import React from 'react';
import ListAllArticles from '@/components/ListAllArticles';
import Navbar from '@/components/Navbar';
import { useRouter } from 'next/navigation';

const ArticlesPage: React.FC = () => {
  const router = useRouter();

  return (
    <div>
      <Navbar />
      <h1 className='text-4xl text-center mt-8'>Articles</h1>
      <ListAllArticles />
    </div>
  );
};

export default ArticlesPage;