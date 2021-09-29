import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function putMainDeveloper(token: string, id: string, bodyData: any) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/manager/notary/developer/${id}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'PUT',
      bodyData,
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
