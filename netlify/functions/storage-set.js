const { getStore } = require('@netlify/blobs');

exports.handler = async function(event) {
    try {
        const store = getStore('bringmine-data');
        const { key, value } = JSON.parse(event.body);
        
        if (!key) {
            return { statusCode: 400, body: JSON.stringify({ error: 'Key required' }) };
        }
        
        await store.set(key, JSON.stringify(value));
        
        return {
            statusCode: 200,
            body: JSON.stringify({ success: true, key: key })
        };
    } catch(error) {
        return { statusCode: 500, body: JSON.stringify({ error: error.message }) };
    }
};