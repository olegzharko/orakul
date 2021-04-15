import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function deleteManagerClient(
  token: string,
  clientId: string,
  cardId: string,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/manager/client/delete/${clientId}/${cardId}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'DELETE',
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log(err);
    return null;
  }
}
