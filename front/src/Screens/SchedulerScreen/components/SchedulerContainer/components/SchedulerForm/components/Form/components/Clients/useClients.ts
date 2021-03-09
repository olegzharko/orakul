import { useCallback } from 'react';
import { ClientItem } from '../../../../../../../../../../types';

export type Props = {
  clients: ClientItem[];
  onChange: (index: number, value: ClientItem) => void;
  onAdd: () => void;
};

export const useClients = ({ onChange, clients }: Props) => {
  const onPhoneChange = useCallback(
    (index: number, value: string) => {
      onChange(index, {
        ...clients[index],
        phone: value,
      });
    },
    [clients]
  );

  const onNameChange = useCallback(
    (index: number, value: string) => {
      onChange(index, {
        ...clients[index],
        full_name: value,
      });
    },
    [clients]
  );

  return { onPhoneChange, onNameChange };
};