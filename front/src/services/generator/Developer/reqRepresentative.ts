import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqRepresentative(
  token: string,
  id: string,
  method: 'POST' | 'GET' = 'GET',
  bodyData?: any,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/developer/representative/${id}`,
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
