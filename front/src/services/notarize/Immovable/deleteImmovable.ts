import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function deleteImmovable(
  token: string,
  clientId: string,
  immovableId: string,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/manager/immovable/delete/${immovableId}/${clientId}`,
      headers: { Authorization: `Bearer ${token}` },
      method: 'DELETE',
    });

    return data;
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error(err);
    return null;
  }
}
