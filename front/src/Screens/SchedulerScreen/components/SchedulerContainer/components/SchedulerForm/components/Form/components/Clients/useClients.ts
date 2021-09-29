import { useCallback } from 'react';
import { CodeFixAction } from 'typescript';
import { ClientItem } from '../../../../../../../../../../types';

export type Props = {
  clients: ClientItem[];
  onChange: (index: number, value: ClientItem) => void;
  onAdd: () => void;
  onRemove: (index: number) => void;
  disabled?: boolean;
};

export const useClients = ({ onChange, clients }: Props) => {
  const onPhoneChange = useCallback(
    (index: number, value: string) => {
      onChange(index, {
        ...clients[index],
        phone: value,
      });
    },
    [clients, onChange]
  );

  const onNameChange = useCallback(
    (index: number, value: string) => {
      onChange(index, {
        ...clients[index],
        full_name: value,
      });
    },
    [clients, onChange]
  );

  return { onPhoneChange, onNameChange };
};
