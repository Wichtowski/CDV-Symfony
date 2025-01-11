import axiosInstance from '@/api/axiosInstance';

export const getAllAuthors = async () => {
    try {
        const response = await axiosInstance.get('/authors/get/all');
        return response.data;
    } catch (error) {
        throw error;
    }
};
