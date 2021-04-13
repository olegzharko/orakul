import { useSelector, useDispatch } from 'react-redux';
import { useState, useCallback } from 'react';
import putMainDeveloper from '../../../../../../../../../../../../services/manager/Main/putMainDeveloper';
import { ManagerParticipantsData } from '../../useManagerMain';
import { State } from '../../../../../../../../../../../../store/types';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';

export type Props = {
  initialData?: ManagerParticipantsData;
  cardId: string;
};

export const useParticipants = ({ initialData, cardId }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState({
    developer_id: initialData?.developer_id || null,
    notary_id: initialData?.notary_id || null,
    representative_id: initialData?.representative_id || null,
    manager_id: initialData?.manager_id || null,
    generator_id: initialData?.generator_id || null,
  });

  const onClear = useCallback(() => {
    setData({
      developer_id: null,
      notary_id: null,
      representative_id: null,
      manager_id: null,
      generator_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const res = await putMainDeveloper(token, cardId, data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );
    }
  }, [data, cardId, token]);

  return {
    data,
    setData,
    onClear,
    onSave,
  };
};
