import { DEFAULT_URL } from '../../Constants';
import requestApi from '../../utils/requestApi';

export default async function getArchiveTools(token: string) {
  const res = await requestApi({
    url: `${DEFAULT_URL}/api/archive/tools`,
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!res.success) throw new Error(res.message);

  return res.data;
}
