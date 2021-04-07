import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqClientConsents(
  token: string,
  clientId: string,
  personId: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  bodyData?: any
) {
  const url = method === 'GET' ? `/api/generator/client/consents/${clientId}/${personId}` : `/api/generator/client/consents/${personId}`;
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
