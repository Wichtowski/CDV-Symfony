import axiosInstance from '@/api/axiosInstance';

export const getSingleArticle = async (id: number) => {
    try {
        const response = await axiosInstance.get(`/api/articles/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
