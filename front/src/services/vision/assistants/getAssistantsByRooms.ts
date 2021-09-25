import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getAssistantsByRooms(token: string) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/staff/info`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res.success) throw new Error(res.message);

  return res.data;
}
