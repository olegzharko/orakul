import React from 'react';
import InputWithCopy from '../../../../components/InputWithCopy';
import SectionWithTitle from '../../../../components/SectionWithTitle';
import Check from '../Check';
import { Props, useDeveloper } from './useDeveloper';

const Developer = (props: Props) => {
  const meta = useDeveloper(props);

  if (!props.developer) {
    return null;
  }

  return (
    <div className="registrator__developer">
      <SectionWithTitle title={props.developer.title}>
        <div className="grid">
          <InputWithCopy label="ПІБ" value={props.developer.full_name} disabled />
          <InputWithCopy label="Код" value={props.developer.tax_code} disabled />
        </div>
      </SectionWithTitle>

      <Check
        data={props.developer}
        setData={meta.setData}
        onPrevButtonClick={meta.onPrevButtonClick}
        onSave={meta.onSave}
        onNextButtonClick={meta.onNextButtonClick}
        disableSaveButton={meta.disableSaveButton}
        next={props.developer.next}
        prev={props.developer.prev}
      />
    </div>
  );
};

export default Developer;
