/* eslint-disable comma-dangle */
type RequestOptions = {
  url: string;
  method?: 'GET' | 'POST' | 'DELETE' | 'PATCH';
  bodyData?: any;
  headers?: {};
};

const requestApi = async (options: RequestOptions) => {
  // eslint-disable-next-line object-curly-newline
  const { url, method = 'GET', headers = {}, bodyData } = options;

  const params = {
    body: undefined as string | undefined,
    method: method || 'GET',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'applicatioin/json',
      ...headers,
    },
  };

  if (bodyData) {
    params.body = JSON.stringify(bodyData);
  }

  const res: any = await fetch(url, params);
  const json: any = await res.json();

  if (!json.success) {
    const { status, message } = res;
    throw new Error(
      `[${status}, ${message}] Could not fetch on URL (${url}) data:\n${JSON.stringify(
        json,
        null,
        2
      )}`
    );
  }

  return json.data;
};

export default requestApi;
