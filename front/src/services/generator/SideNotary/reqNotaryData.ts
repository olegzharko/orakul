import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqNotaryData(
  token: string,
  id: string,
  clientId: string,
  method: 'GET' | 'PUT' = 'GET',
  bodyData?: any,
) {
  const url = method === 'PUT' ? `/api/generator/client/notary/${clientId}${id && `/${id}`}` : `/api/generator/client/notary/${id}`;
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
      method,
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
