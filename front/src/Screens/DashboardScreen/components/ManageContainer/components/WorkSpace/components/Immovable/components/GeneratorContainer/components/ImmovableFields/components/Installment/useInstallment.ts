import { useState, useCallback, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableInstallment from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableInstallment';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';

type InitialData = {
  total_month: string | null
  total_price: string | null,
  type: any
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

// eslint-disable-next-line no-shadow
export enum InstallmentRadioButtons {
  MONTH='month',
  QUARTER='quarter'
}

const installmentRadioButtons = [
  {
    id: InstallmentRadioButtons.MONTH,
    title: 'Щомісячно'
  },
  {
    id: InstallmentRadioButtons.QUARTER,
    title: 'Поквартально'
  }
];

export const useInstallment = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    total_month: null,
    total_price: null,
    type: InstallmentRadioButtons.MONTH
  });

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqImmovableInstallment(token, id, 'PUT', data);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  const onClear = useCallback(() => {
    setData({
      total_month: null,
      total_price: null,
      type: InstallmentRadioButtons.MONTH
    });
  }, []);

  useEffect(() => {
    setData({
      total_month: initialData?.total_month || null,
      total_price: initialData?.total_price || null,
      type: initialData?.type || InstallmentRadioButtons.MONTH
    });
  }, [initialData]);

  return {
    installmentRadioButtons,
    data,
    setData,
    onSave,
    onClear
  };
};
