'use client';

import React from 'react';
import ListAllAuthors from '@/components/ListAllAuthors';
import Navbar from '@/components/Navbar';

const ArticlesPage: React.FC = () => {

  return (
    <div>
      <Navbar />
      <h1 className='text-4xl text-center mt-8'>Authors</h1>
      <ListAllAuthors />
    </div>
  );
};

export default ArticlesPage;