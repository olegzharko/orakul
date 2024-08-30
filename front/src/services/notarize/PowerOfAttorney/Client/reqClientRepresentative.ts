import { DEFAULT_URL } from '../../../Constants';
import requestApi from '../../../utils/requestApi';

export default async function reqClientRepresentative(
  token: string,
  clientId: string,
  personId: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  bodyData?: any
) {
  try {
    const url = method === 'GET'
      ? `/api/generator/client/representative/${clientId}/${personId}`
      : `/api/generator/client/representative/${personId}`;

    const data = await requestApi({
      url: `${DEFAULT_URL}${url}`,
      headers: { Authorization: `Bearer ${token}` },
      method,
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
