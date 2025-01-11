import axiosInstance from '@/api/axiosInstance';

export const getSingleAuthor = async (id: number) => {
    try {
        const response = await axiosInstance.get(`/author/get/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
