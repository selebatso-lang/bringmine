const { getStore } = require('@netlify/blobs');

exports.handler = async function(event) {
    try {
        const store = getStore('bringmine-data');
        const key = event.queryStringParameters.key;
        
        if (!key) {
            return { statusCode: 400, body: JSON.stringify({ error: 'Key required' }) };
        }
        
        const data = await store.get(key, { consistency: 'strong' });
        
        return {
            statusCode: 200,
            headers: { 'Content-Type': 'application/json' },
            body: data || '{}'
        };
    } catch(error) {
        return { statusCode: 500, body: JSON.stringify({ error: error.message }) };
    }
};