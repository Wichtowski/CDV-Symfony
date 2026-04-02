import axiosInstance from '@/api/axiosInstance';

export const getSingleAuthor = async (id: number | string) => {
    try {
        const response = await axiosInstance.get(`/api/users/authors/articles/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
