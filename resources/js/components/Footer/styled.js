import styled from 'styled-components';
import { common } from '../../theme/palette';

const Footer = styled.div`
  background: ${common.black};
  color: ${common.white};
  display: flex;
  justify-content: space-between;
  padding: 1rem 1.5rem;
`;

export default { Footer };
