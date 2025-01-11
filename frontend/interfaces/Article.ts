export interface Article {
    id?: number;
    title: string;
    author: string;
    content: string;
    created_at?: string;
}

export interface CreateArticle {
    title: string;
    authorName?: string;
    authorId?: number;
    content: string;
    created_at?: string;
}
