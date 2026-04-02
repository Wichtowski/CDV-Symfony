'use client';

import React from 'react';
import ListSingleArticle from '@/components/ListSingleArticle';
import { useRouter } from 'next/navigation';

export default function SingleArticlePage({ params, }: { params: Promise<{ id: string }> }) {
  const id: number = Number(React.use(params).id);
  const router = useRouter();

  return (
    <div>
      <ListSingleArticle articleID={id} />
    </div>
  );
};
