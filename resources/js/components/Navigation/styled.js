import styled from 'styled-components';
import { common } from '@theme/palette';
import { size } from '@theme/typography';

const Navigation = styled.div`
  display: flex;
  align-items: center;
`;

const Link = styled.a`
  color: ${common.white};
  font-size: ${size.max};
  & + & {
    margin-left: 2rem;
  }
`;

export default { Navigation, Link };
