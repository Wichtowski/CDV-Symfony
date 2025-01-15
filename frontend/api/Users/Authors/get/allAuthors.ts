import axiosInstance from '@/api/axiosInstance';

export const getAllAuthors = async () => {
    try {
        const response = await axiosInstance.get('/api/users/authors');
        return response.data;
    } catch (error) {
        throw error;
    }
};
