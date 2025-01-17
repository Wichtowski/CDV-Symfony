import { create } from 'zustand';
import { Article } from '@/interfaces/Article';
import { Author } from '@/interfaces/Users';
import { getAllArticles } from '@/api/Articles/get/getAllArticles';
import { getAllAuthors } from '@/api/Users/Authors/get/getAllAuthors';

export type FetchStatus = 'NotReady' | 'Fetching' | 'Ready' | 'Error';

export interface ArticlesStore {
    articles: Article[];
    authors: Author[];
    articlesStatus: FetchStatus;
    authorsStatus: FetchStatus;
    loadArticles: () => void;
    loadAuthors: () => void;
}

export const useArticlesStore = create<ArticlesStore>((set, get) => {
    const loadData = async <T>(currentStatus: FetchStatus, statusField: string, fetchFunction: () => Promise<T>) => {
        if (currentStatus === 'NotReady') {
            set(() => ({ [statusField]: 'Fetching' }));
            try {
                const result = await fetchFunction();
                set(() => ({
                    ...result,
                    [statusField]: 'Ready',
                }));
            } catch (error) {
                set(() => ({ [statusField]: 'Error' }));
                console.error(error);
            }
        }
    };

    const loadSimpleData = async <T>(
        currentStatus: FetchStatus,
        statusField: string,
        resultField: string,
        fetchFunction: () => Promise<T>
    ) => {
        await loadData(currentStatus, statusField, async () => {
            const result = await fetchFunction();
            return { [resultField]: result };
        });
    };

    return {
        articles: [],
        authors: [],
        articlesStatus: 'NotReady',
        authorsStatus: 'NotReady',
        loadArticles: async () => {
            const { articlesStatus, articles } = get();
            await loadData(articlesStatus, 'articlesStatus', async () => {
                const articles = await getAllArticles();
                return { articles };
            });
        },
        loadAuthors: async () => {
            const { authorsStatus, authors } = get();
            await loadData(authorsStatus, 'authorsStatus', async () => {
                const authors = await getAllAuthors();
                return { authors };
            });
        }
    };
});

