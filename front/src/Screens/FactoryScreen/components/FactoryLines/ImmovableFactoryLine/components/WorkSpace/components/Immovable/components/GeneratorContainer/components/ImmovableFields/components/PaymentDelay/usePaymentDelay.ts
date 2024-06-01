import { useState, useCallback, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import reqImmovablePaymentDelay from '../../../../../../../../../../../../../../../services/generator/Immovable/reqImmovablePaymentDelay';
import { setModalInfo } from '../../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../../store/types';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
    contractNumber: number | null;
    paymentDate: any;
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const usePaymentDelay = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    contractNumber: null,
    paymentDate: null
  });

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        paymentDate: formatDate(data.paymentDate)
      };

      const { success, message } = await reqImmovablePaymentDelay(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, dispatch, id, token]);

  const onClear = useCallback(() => {
    setData({
      contractNumber: null,
      paymentDate: null
    });
  }, []);

  useEffect(() => {
    setData({
      contractNumber: initialData?.contractNumber || null,
      paymentDate: initialData?.paymentDate
        ? changeMonthWitDate(initialData?.paymentDate) : null
    });
  }, [initialData]);

  return {
    data,
    setData,
    onSave,
    onClear
  };
};
