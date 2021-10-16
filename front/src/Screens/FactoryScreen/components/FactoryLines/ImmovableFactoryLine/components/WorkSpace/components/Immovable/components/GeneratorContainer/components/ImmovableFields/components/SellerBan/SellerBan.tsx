import * as React from 'react';

import CheckBanFields from '../../../../../../../../../../../../../../../components/CheckBanFields';
import PrimaryButton from '../../../../../../../../../../../../../../../components/PrimaryButton';

import { useSellerBan, Props } from './useSellerBan';

const SellerBan = (props: Props) => {
  const meta = useSellerBan(props);

  return (
    <>
      <CheckBanFields data={meta.data} setData={meta.setData} title="Заборони на нерухомість" />
      <div className="middle-button">
        <PrimaryButton label="Зберегти" onClick={meta.onSave} disabled={meta.disableSaveButton} />
      </div>
    </>
  );
};

export default SellerBan;
