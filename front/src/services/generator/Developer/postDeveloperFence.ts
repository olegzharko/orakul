import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function postDeveloperFence(
  token: string,
  developerId: string,
  cardId: string,
  method: 'POST',
  bodyData: any,
) {
  try {
    const data = await requestApi({
      url: `${DEFAULT_URL}/api/generator/developer/fence/${developerId}/${cardId}`,
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
