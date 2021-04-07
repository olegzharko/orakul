import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientName(
  token: string,
  id: string,
  method: 'GET' | 'PUT' | 'DELETE' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const url = method === 'DELETE' ? `/api/generator/client/delete/${id}` : `/api/generator/client/name/${id}`;

    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
      method: method === 'DELETE' ? 'GET' : method,
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
