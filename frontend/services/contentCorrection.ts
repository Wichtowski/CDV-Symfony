import * as fs from 'fs';
import { resolve } from 'path';
import sanitizeHtml from 'sanitize-html';

export const correction = async (content: string) => {
    const sanitizedContent = sanitizeHtml(content, {
        allowedTags: [],
        allowedAttributes: {}
    });

    return sanitizedContent;
};