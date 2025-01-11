import axiosInstance from '@/api/axiosInstance';

export const getAllArticles = async () => {
    try {
        const response = await axiosInstance.get('/articles/get/all');
        return response.data;
    } catch (error) {
        throw error;
    }
};
