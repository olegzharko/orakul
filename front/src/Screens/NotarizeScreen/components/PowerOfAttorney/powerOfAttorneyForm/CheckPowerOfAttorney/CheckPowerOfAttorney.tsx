import React from 'react';
import PowerOfAttorneyFields, { PowerOfAttorneyData } from '../../../../../../components/powerOfAttorney/PowerOfAttorneyFields';
import CustomDatePicker from '../../../../../../components/CustomDatePicker';
import CustomInput from '../../../../../../components/CustomInput';
import CustomSwitch from '../../../../../../components/CustomSwitch';
import PrimaryButton from '../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../components/SectionWithTitle';

type Props = {
  data: PowerOfAttorneyData,
  setData: (data: PowerOfAttorneyData) => void,
  onSave: () => void,
  disableSaveButton: boolean,
}

const CheckPowerOfAttorney = ({
  data,
  setData,
  onSave,
  disableSaveButton,
}: Props) => (
  <>
    <PowerOfAttorneyFields data={data} setData={setData} title="Довіреність" />
    <div className="buttons-group" style={{ justifyContent: 'center' }}>
      <div className="button-container">
        <PrimaryButton label="Зберегти" onClick={onSave} disabled={disableSaveButton} />
      </div>
    </div>
  </>
);

export default CheckPowerOfAttorney;
