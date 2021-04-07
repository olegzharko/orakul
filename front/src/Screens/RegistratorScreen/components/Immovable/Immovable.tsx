import React, { memo } from 'react';
import InputWithCopy from '../../../../components/InputWithCopy';
import SectionWithTitle from '../../../../components/SectionWithTitle';
import Check from '../Check';
import { Props, useImmovable } from './useImmovable';

const Immovable = (props: Props) => {
  const meta = useImmovable(props);

  if (!props.immovable) {
    return null;
  }

  return (
    <div className="registrator__immovable">
      <SectionWithTitle title={props.immovable.title}>
        <div className="grid">
          <InputWithCopy label="Реєстраційни номер" value={props.immovable.immovable_code} disabled />
        </div>
      </SectionWithTitle>

      <Check
        data={meta.data}
        setData={meta.setData}
        onPrevButtonClick={meta.onPrevButtonClick}
        onSave={meta.onSave}
        onNextButtonClick={meta.onNextButtonClick}
        disableSaveButton={meta.disableSaveButton}
        next={props.immovable.next}
        prev={props.immovable.prev}
      />
    </div>
  );
};

export default memo(Immovable);
