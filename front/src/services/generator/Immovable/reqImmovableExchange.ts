import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function reqImmovableExchange(
  token: string,
  id?: string,
  method: 'GET' | 'PUT' | undefined = 'GET',
  type?: 'MINFIN' | null,
  bodyData?: any
) {
  try {
    const url = type === 'MINFIN' ? '/api/exchange' : `/api/generator/immovable/exchange/${id}`;
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
