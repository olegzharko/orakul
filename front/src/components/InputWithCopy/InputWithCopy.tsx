import * as React from 'react';
import './index.scss';
import { useState, useEffect } from 'react';
import CustomInput from '../CustomInput';

type Props = {
  label: string;
  value: string;
  onChange?: (val: string) => void;
  disabled?: boolean;
}

const InputWithCopy = ({ label, value, disabled, onChange }: Props) => {
  const [done, setDone] = useState<boolean>(false);

  const handleSave = React.useCallback(() => {
    if (!value) return;

    navigator.clipboard.writeText(value);

    setDone(true);
    setTimeout(() => setDone(false), 3000);
  }, [value]);

  return (
    <div className="clipboard-input">
      <CustomInput label={label} onChange={onChange} value={value} disabled={disabled} />
      <button
        type="button"
        onClick={handleSave}
      >
        {done ? <img src="/icons/check.svg" alt="copy" /> : <img src="/icons/copy.svg" alt="copy" />}
      </button>
    </div>
  );
};

export default InputWithCopy;
