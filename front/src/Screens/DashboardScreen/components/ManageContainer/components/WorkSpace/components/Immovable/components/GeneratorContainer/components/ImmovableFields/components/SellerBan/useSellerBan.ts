import { useState, useCallback, useEffect, useMemo } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableSellerBan from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableSellerBan';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  date: any,
  number: string,
  pass: boolean,
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useSellerBan = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    date: null,
    number: '',
    pass: false,
  });

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        number: data.number,
        date: formatDate(data.date),
      };

      const { success, message } = await reqImmovableSellerBan(token, id, 'PUT', reqData);

      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  useEffect(() => {
    setData({
      date: initialData?.date ? changeMonthWitDate(initialData?.date) : null,
      number: initialData?.number || '',
      pass: initialData?.pass || false,
    });
  }, [initialData]);

  return {
    data,
    disableSaveButton,
    setData,
    onSave,
  };
};
