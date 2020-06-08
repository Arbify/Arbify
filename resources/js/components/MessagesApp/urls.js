const messageData = (projectId) => `/projects/${projectId}/messages/data`;
const storeMessage = (projectId) => `/projects/${projectId}/messages`;
const updateMessage = (projectId, messageId) => `/projects/${projectId}/messages/${messageId}`;
const deleteMessage = (projectId, messageId) => `/projects/${projectId}/messages/${messageId}`;
const putMessageValue = (projectId, messageId, languageId, form) =>
    `/projects/${projectId}/messages/${messageId}/${languageId}/${form ? form : ''}`;
const messageValueHistory = (projectId, messageId, languageId, form) =>
    `/projects/${projectId}/messages/${messageId}/${languageId}/history${form ? '?form=' + form : ''}`;

export {
    messageData,
    storeMessage,
    updateMessage,
    deleteMessage,
    putMessageValue,
    messageValueHistory,
};
