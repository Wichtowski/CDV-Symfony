import axiosInstance from '@/api/axiosInstance';
import { Article } from '@/interfaces/Article';
import { Author } from '@/interfaces/Users';

export const createNewArticle = async (article: Article) => {
    try {
        if (!article.title || !article.content || !article.author) {
            throw new Error('Title and content are required');
        }

        article.author = article.author.toLocaleLowerCase().replace(/\s+/g, '-');
        const isAuthorValid = await axiosInstance.get(`/authors/get/${article.author}`);
        if (isAuthorValid.data.error || isAuthorValid.data.authorName !== article.author) {
            throw new Error('Author does not exist');
        }

        const response = await axiosInstance.post(`/articles/post/create`, article);
        
        return response.data;
    } catch (error) {
        throw error;
    }
};
